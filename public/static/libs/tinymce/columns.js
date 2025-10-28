tinymce.PluginManager.add('twocolumn', function(editor, url) {
  
  // Dialog megnyitása opciókkal
  const openColumnDialog = function() {
    editor.windowManager.open({
      title: 'Kétoszlopos elrendezés beállítások',
      body: {
        type: 'panel',
        items: [
          {
            type: 'selectbox',
            name: 'ratio',
            label: 'Oszlop arány',
            items: [
              { text: '50% - 50%', value: '1-1' },
              { text: '33% - 66%', value: '1-2' },
              { text: '66% - 33%', value: '2-1' },
              { text: '25% - 75%', value: '1-3' },
              { text: '75% - 25%', value: '3-1' }
            ]
          },
          {
            type: 'input',
            name: 'gap',
            label: 'Távolság az oszlopok között (px)',
            placeholder: '20'
          },
          {
            type: 'selectbox',
            name: 'border',
            label: 'Szegély stílus',
            items: [
              { text: 'Szaggatott szegély', value: 'dashed' },
              { text: 'Folytonos szegély', value: 'solid' },
              { text: 'Nincs szegély', value: 'none' }
            ]
          },
          {
            type: 'colorinput',
            name: 'borderColor',
            label: 'Szegély szín'
          },
          {
            type: 'input',
            name: 'padding',
            label: 'Belső margó (px)',
            placeholder: '15'
          },
          {
            type: 'input',
            name: 'minHeight',
            label: 'Minimum magasság (px)',
            placeholder: '100'
          },
          {
            type: 'checkbox',
            name: 'responsive',
            label: 'Mobilon egymás alatt (responsive)'
          }
        ]
      },
      buttons: [
        {
          type: 'cancel',
          text: 'Mégse'
        },
        {
          type: 'submit',
          text: 'Beszúrás',
          primary: true
        }
      ],
      initialData: {
        ratio: '1-1',
        gap: '20',
        border: 'dashed',
        borderColor: '#cccccc',
        padding: '15',
        minHeight: '100',
        responsive: true
      },
      onSubmit: function(api) {
        const data = api.getData();
        insertCustomColumnLayout(data);
        api.close();
      }
    });
  };
  
  // Egyedi layout beillesztése
  const insertCustomColumnLayout = function(options) {
    const ratios = options.ratio.split('-');
    const flex1 = ratios[0];
    const flex2 = ratios[1];
    const gap = options.gap || '20';
    const borderStyle = options.border || 'dashed';
    const borderColor = options.borderColor || '#cccccc';
    const padding = options.padding || '15';
    const minHeight = options.minHeight || '100';
    const responsive = options.responsive;
    
    const borderCss = borderStyle !== 'none' ? `border: 1px ${borderStyle} ${borderColor};` : '';
    
    const responsiveCss = responsive ? `
      @media (max-width: 768px) {
        .two-column-layout { flex-direction: column !important; }
      }
    ` : '';
    
    const columnHtml = `
      ${responsiveCss ? `<style>${responsiveCss}</style>` : ''}
      <div class="two-column-layout" style="display: flex; gap: ${gap}px; margin: 20px 0;">
        <div class="column column-left" style="flex: ${flex1}; ${borderCss} padding: ${padding}px; min-height: ${minHeight}px;">
          <p>Bal oldali oszlop...</p>
        </div>
        <div class="column column-right" style="flex: ${flex2}; ${borderCss} padding: ${padding}px; min-height: ${minHeight}px;">
          <p>Jobb oldali oszlop...</p>
        </div>
      </div>
      <p>&nbsp;</p>
    `;
    
    editor.insertContent(columnHtml);
  };
  
  // Gyors beszúrás alapértelmezett beállításokkal
  const insertQuickLayout = function() {
    const columnHtml = `
      <div class="two-column-layout" style="display: flex; gap: 20px; margin: 20px 0;">
        <div class="column" style="flex: 1; border: 1px dashed #ccc; padding: 15px; min-height: 100px;">
          <p>Bal oldali oszlop tartalma...</p>
        </div>
        <div class="column" style="flex: 1; border: 1px dashed #ccc; padding: 15px; min-height: 100px;">
          <p>Jobb oldali oszlop tartalma...</p>
        </div>
      </div>
      <p>&nbsp;</p>
    `;
    
    editor.insertContent(columnHtml);
  };
  
  // Toolbar gomb regisztrálása (split button - kétféle működés)
  editor.ui.registry.addSplitButton('twocolumn', {
    icon: 'table',
    tooltip: 'Kétoszlopos elrendezés',
    onAction: function() {
      // Főgomb kattintás - gyors beszúrás
      insertQuickLayout();
    },
    onItemAction: function(api, value) {
      if (value === 'custom') {
        openColumnDialog();
      } else if (value === 'quick') {
        insertQuickLayout();
      }
    },
    fetch: function(callback) {
      const items = [
        {
          type: 'choiceitem',
          text: 'Gyors beszúrás (50-50)',
          value: 'quick'
        },
        {
          type: 'choiceitem',
          text: 'Testreszabott...',
          value: 'custom'
        }
      ];
      callback(items);
    }
  });
  
  // Menüpont regisztrálása
  editor.ui.registry.addNestedMenuItem('twocolumn', {
    icon: 'table',
    text: 'Oszlopos elrendezés',
    getSubmenuItems: function() {
      return [
        {
          type: 'menuitem',
          text: 'Két oszlop (50-50)',
          onAction: function() {
            insertQuickLayout();
          }
        },
        {
          type: 'menuitem',
          text: 'Testreszabott...',
          onAction: function() {
            openColumnDialog();
          }
        }
      ];
    }
  });
  
  // CSS hozzáadása a szerkesztőhöz (opcionális)
  editor.on('init', function() {
    editor.dom.addStyle(`
      .two-column-layout {
        display: flex;
        gap: 20px;
        margin: 20px 0;
      }
      .column {
        flex: 1;
        padding: 15px;
        min-height: 100px;
      }
      @media (max-width: 768px) {
        .two-column-layout {
          flex-direction: column;
        }
      }
    `);
  });
  
  return {
    getMetadata: function() {
      return {
        name: 'Two Column Layout Plugin',
        url: 'http://exampleurl.com'
      };
    }
  };
});