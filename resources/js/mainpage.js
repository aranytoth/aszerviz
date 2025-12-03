import './jquery';

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    window.pageEditor = {
        root: document.querySelector('#app'),
        blocks: [],
        init: function () {
            // ha van adat
            if (this.root.dataset.id) {
                this.blocks = JSON.parse(this.root.dataset.blocks);
                // AJAX hívás
                $.ajax({
                    url: '/admin/mainpage/' + this.root.dataset.id,
                    type: 'GET',
                    success: function (data) {
                        this.blocks = data.blocks;
                    }.bind(this)
                });
            }
            // ha nincs adat
            else {
                this.blocks = [];
            }
        },

        addBlock: function (parent = false) {

        }
    }
})