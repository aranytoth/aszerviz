tinymce.PluginManager.add('gallery', function(editor, url) {
  
  // 1. Eseményfigyelő regisztrálása (Global Event Delegation)
  // Mivel a dialog HTML-je dinamikusan jön létre, a document-re tesszük a figyelőt,
  // és azt figyeljük, hogy a kattintás a mi galériánkon belül történt-e.
  const registerGlobalEvents = () => {
    // Ellenőrizzük, hogy ne adjuk hozzá többször a figyelőt
    if (editor.galleryEventsInitialized) return;
    
    document.addEventListener('click', (e) => {
      // Megkeressük a legközelebbi gallery-item elemet a kattintás helyén
      const target = e.target.closest('.tox-dialog .gallery-item');
      
      if (target) {
        const src = target.getAttribute('data-src');
        const alt = target.getAttribute('data-alt');
        
        if (src) {
          // Beszúrás
          editor.insertContent(`<img src="${src}" alt="${alt}" />`);
          
          // Ablak bezárása a globális API-val (mindig a legfelsőt zárja)
          editor.windowManager.close();
        }
      }
    });
    
    editor.galleryEventsInitialized = true;
  };

  

  // 2. A Galéria HTML felépítése (Segédfüggvény)
  const buildGalleryHtml = (responseWrapper) => {
    const images = responseWrapper.data || []; 
    const paginator = responseWrapper.meta.links || [];
    if (!images || images.length === 0) {
      return '<p style="text-align:center; padding: 20px;">Nincsenek elérhető képek.</p>';
    }

    let html = '<div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">';
    
    images.forEach(image => {
      // Biztonságos attribútum kezelés
      const safeSrc = image.original_url; // Itt érdemes lenne escape-elni, ha user input
      const safeAlt = (image.alt || '').replace(/"/g, '&quot;');
      const safeThumb = image.thumb_url || image.original_url;
      
      html += `
        <div class="gallery-item" 
             style="cursor: pointer; border: 2px solid #eee; padding: 4px; border-radius: 4px; transition: all 0.2s;" 
             data-src="${safeSrc}" 
             data-alt="${safeAlt}"
             onmouseover="this.style.borderColor='#0066cc'; this.style.backgroundColor='#f0f7ff';"
             onmouseout="this.style.borderColor='#eee'; this.style.backgroundColor='transparent';">
            <div style="width: 100%; padding-top: 75%; position: relative; background: #f4f4f4;">
                <img src="${safeThumb}" 
                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 2px; pointer-events: none;">
            </div>
            <div style="margin-top: 5px; font-size: 12px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; pointer-events: none;">
                ${image.name || 'Kép'}
            </div>
        </div>
      `;
    });

    let paginateHtml = '<ul class="pagination" style="display: flex">'
    paginator.forEach(item => {
      if(item.active){
        var btn = `<span href="" class="btn btn-primary">${item.label}</span>`;
      } else {
        var btn = `<a href="" class="btn btn-primary">${item.label}</a>`;
      }
      paginateHtml += `<li style="list-style-type: none; padding: 0 10px;"></li>`;
    });
    paginateHtml += '</ul>';
    html += '</div>'+paginateHtml;
    return html;
  };

  // 3. A folyamat: Megnyitás -> Betöltés -> Redial
  const openGalleryDialog = function(page = 0) {
    // A. Megnyitjuk az ablakot "Betöltés..." állapottal
    // Fontos: eltároljuk az API példányt
    const dialogApi = editor.windowManager.open({
      title: 'Képgaléria',
      size: 'medium', // large helyett medium vagy large
      body: {
        type: 'panel',
        items: [
          {
            type: 'htmlpanel',
            html: '<div style="display:flex; justify-content:center; align-items:center; height: 300px;"><p>Képek betöltése...</p></div>'
          }
        ]
      },
      buttons: [
        {
          type: 'cancel',
          text: 'Mégse'
        }
      ]
    });

    // B. Elindítjuk az AJAX kérést
    fetch('/api/v1/gallery/images?page='+page)
      .then(response => response.json())
      .then(responseWrapper => {
        // Feltételezve, hogy a válasz { data: [...] } formátumú
        //const images = responseWrapper.data || []; 
        const galleryHtml = buildGalleryHtml(responseWrapper);

        // C. REDIAL: Újrarajzoljuk az ablakot a tartalommal
        dialogApi.redial({
          title: 'Képgaléria',
          size: 'medium',
          body: {
            type: 'panel',
            items: [
              {
                type: 'htmlpanel',
                html: `<div style="max-height: 500px; overflow-y: auto;">${galleryHtml}</div>`
              }
            ]
          },
          buttons: [
            {
              type: 'cancel',
              text: 'Bezárás'
            }
          ]
        });
      })
      .catch(error => {
        console.error('Galéria hiba:', error);
        dialogApi.redial({
          title: 'Hiba',
          body: {
            type: 'panel',
            items: [
              {
                type: 'htmlpanel',
                html: '<p style="color: red; text-align: center; padding: 20px;">Nem sikerült betölteni a képeket.</p>'
              }
            ]
          },
          buttons: [{ type: 'cancel', text: 'Bezárás' }]
        });
      });
  };

  // Inicializáláskor regisztráljuk az eseményeket
  editor.on('init', function() {
      registerGlobalEvents();
  });

  // Gomb regisztrálása
  editor.ui.registry.addButton('gallery', {
    icon: 'gallery', // Vagy 'image' ha nincs custom ikon
    tooltip: 'Képgaléria',
    onAction: function() {
      openGalleryDialog(1);
    }
  });
  
  // Menüpont regisztrálása
  editor.ui.registry.addMenuItem('gallery', {
    icon: 'gallery',
    text: 'Kép galériából',
    onAction: function() {
      openGalleryDialog(1);
    }
  });

  return {
    getMetadata: function() {
      return {
        name: 'Modern Gallery Plugin',
        url: 'https://devnomad.hu'
      };
    }
  };
});