
const galleryBtn = document.querySelector('.gallery-show-more');
galleryBtn.addEventListener('click',showImages);

function showImages (e){
    e.preventDefault()
    const expanded = e.target.dataset.expanded;
    let images = [...document.querySelectorAll(".ad-gallery--img")];
    if(expanded==='true'){
            images.forEach((image,index)=>{
                if(index>5){
                    image.classList.add('hidden');
                }
            })
            galleryBtn.dataset.expanded = 'false';
            galleryBtn.innerHTML = "תמונות נוספות";

    }else{
        images.forEach(image=>{
            image.classList.remove('hidden');
        })
        galleryBtn.dataset.expanded = 'true';
        galleryBtn.innerHTML = "הצג פחות תמונות";

    }

}

function lightBox(){

}
