tinymce.PluginManager.add('gallery', function(editor, url) {
  
  // Galéria dialog megnyitása
  const openGalleryDialog = function() {
    editor.windowManager.open({
      title: 'Képgaléria',
      size: 'large',
      body: {
        type: 'panel',
        items: [
          {
            type: 'htmlpanel',
            html: '<div id="gallery-container" style="max-height: 400px; overflow-y: auto;"><p>Képek betöltése...</p></div>'
          }
        ]
      },
      buttons: [
        {
          type: 'cancel',
          text: 'Bezárás'
        }
      ],
      onShow: function(api) {
        console.log('betöltés');
        loadGalleryImages();
      }
    });
  };
  
  // Képek betöltése AJAX-szal
  const loadGalleryImages = function() {
    const container = document.getElementById('gallery-container');
    console.log('ide');
    // AJAX kérés - cseréld le a saját endpoint-odra
    fetch('/api/gallery/images')
      .then(response => response.json())
      .then(images => {
        displayImages(images);
      })
      .catch(error => {
        container.innerHTML = '<p style="color: red;">Hiba a képek betöltése során.</p>';
        console.error('Error:', error);
      });
  };
  
  // Képek megjelenítése
  const displayImages = function(images) {
    const container = document.getElementById('gallery-container');
    
    if (!images || images.length === 0) {
      container.innerHTML = '<p>Nincsenek elérhető képek.</p>';
      return;
    }
    
    let html = '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">';
    
    images.forEach(image => {
      html += `
        <div class="gallery-item" style="cursor: pointer; border: 2px solid #ddd; padding: 5px; border-radius: 5px; transition: border-color 0.3s;" 
             data-src="${image.url}" 
             data-alt="${image.alt || ''}"
             onmouseover="this.style.borderColor='#0066cc'"
             onmouseout="this.style.borderColor='#ddd'"
             onclick="window.insertImageFromGallery('${image.url}', '${image.alt || ''}')">
          <img src="${image.thumbnail || image.url}" 
               alt="${image.alt || ''}" 
               style="width: 100%; height: 150px; object-fit: cover; border-radius: 3px;">
          <p style="margin: 5px 0 0 0; font-size: 12px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
            ${image.name || 'Kép'}
          </p>
        </div>
      `;
    });
    
    html += '</div>';
    container.innerHTML = html;
  };
  
  // Kép beillesztése
  window.insertImageFromGallery = function(src, alt) {
    editor.insertContent(`<img src="${src}" alt="${alt}" />`);
    editor.windowManager.close();
  };
  
  // Toolbar gomb regisztrálása
  editor.ui.registry.addButton('gallery', {
    icon: 'gallery',
    tooltip: 'Kép beszúrása galériából',
    onAction: function() {
      openGalleryDialog();
      loadGalleryImages();
    }
  });
  
  // Menüpont regisztrálása (opcionális)
  editor.ui.registry.addMenuItem('gallery', {
    icon: 'gallery',
    text: 'Kép galériából',
    onAction: function() {
      openGalleryDialog();
    }
  });
  
  return {
    getMetadata: function() {
      return {
        name: 'Image Gallery Plugin',
        url: 'http://exampleurl.com'
      };
    }
  };
});