
window.addEventListener("load", function() {

    // store tabs variables
    var tabs = document.querySelectorAll("ul.nav-tabs > li");

    for (var i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", switchTab);
    }

    function switchTab(event) {
        event.preventDefault();

        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");

        var clickedTab = event.currentTarget;
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");

        clickedTab.classList.add("active");
        document.querySelector(activePaneID).classList.add("active");

    }



});

jQuery(document).ready(function ($){

    $('.field-color-picker').each(function(){
        $(this).wpColorPicker();
    });
    $(document).on('click','.js-image-upload',function (e){
        e.preventDefault();
        let $button = $(this);
        const file_frame  = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Image',
            library:{
                type: 'image',
            },
            button:{
                text:'Select Image'
            },
            multiple:$button.hasClass('multiple'),

        })
        file_frame.on('select',()=>{
            let list = '';
            const attatcments = file_frame.state().get('selection');
            attatcments.forEach((img,index)=>{
                list+= img.toJSON().url
                if(index!==attatcments.length-1){
                    list+=" , ";
                }
            })
            //list of urls.
            $button.siblings('.image-upload').val(list);
            $button.siblings('.display_images').html(display_images(list));

        })

        file_frame.open()

    })

    $(document).on('click','.star_rating_star',(e)=>{
        // get the data value
        const val = $(e.target).data('value');
        // update the input with new numeric value
        $('.star_rating_input_js').val(val);
        // update the visual starts
        // iterate throw all stars and update text to match the new value.
        $('.star_rating_star').each((index,star)=>{
            $(star).text($(star).data('value')>val?"☆":"★");
        })
    })
})


function display_images(list){
    var html = '';
    list.split(",").forEach((img,index)=>{
        html+= `<div class="gallery-image" style="background-image: url(${img});" ></div>`;
    })
    return html;

}