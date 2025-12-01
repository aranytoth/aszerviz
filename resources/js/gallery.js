window.gallery = {
    callback: null,
    obj: null,
    page: 0,
    media: [],
    pagination: [],
    init: function(obj, callback){
        this.obj = obj;
        this.callback = callback;
        this.getMedia();
        
        
    },
    getMedia: async function() {
       await fetch('/api/v1/gallery/images?page='+this.page)
      .then(response => response.json())
      .then(responseWrapper => {
        
        this.media = responseWrapper.data;
        this.pagination = responseWrapper.meta.links;
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = this.render();
        
        document.body.append(tempDiv);
        this.functions();
      })
      .catch(error => {})
    },
    selectMedia: function(){

    },
    functions: function(){
        const parent = this;
        document.querySelector('#gallery-modal').addEventListener('click', (e) => {
            // Megkeressük a legközelebbi gallery-item elemet a kattintás helyén
            const target = e.target.closest('#gallery-modal .gallery-item');
            const close = e.target.closest('#gallery-modal #gallery-close');
            if (target) {
                const src = target.getAttribute('data-src');
                
                if(this.callback.type && this.callback.type == 'livewire'){
                    var component = Livewire.find(parent.obj.component);
                    component.call(parent.callback.callback, { image: src, obj: parent.obj });
                    
                } else {
                    // szimpla callback
                }
                
                document.querySelector('#gallery-modal').remove();
            }

            if(close){
                document.querySelector('#gallery-modal').remove();
            }
        });
        
    },
    render: function(){
        var list = '';
        var paginator = '';
        if(this.pagination){
            this.pagination.forEach(elem => {
                paginator += `<li data-page="${elem.page}" class="${elem.active ? 'active' : 'inactive'}">${elem.label}</li>`;
            });
        }
        this.media.forEach(elem => {
            list += `<div class="gallery-item" data-src="${elem.original_url}" style="cursor: pointer; border: 2px solid #eee; padding: 4px; border-radius: 4px; transition: all 0.2s;">
                <div style="width: 100%; padding-top: 75%; position: relative; background: #f4f4f4;">
                    <img src="${elem.thumb_url}"  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 2px; pointer-events: none;">
                </div>
            </div>`;
        });
        return `
        <div id="gallery-modal" style="position: fixed; left: 0; top: 0;  width: 100%; height: 100%; background-color: rgba(0,0,0, 0.4); padding: 5%;">
            <div id="gallery-body" style="position: relative; width: 100%; padding-top: 30px; background-color: #fff;">
                <button id="gallery-close" style="position: absolute; right: 5px; top: 5px; border: 1px solid #ddd; border-radius: 4px; padding: 3px;">Bezár</button>
                <div id="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; padding: 10px; ">
                    ${list}
                </div>
                <ul class="pagination">${paginator}</ul>
            </div>
        </div>`;
    }
}