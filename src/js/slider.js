function activateSliders(){

const sliders =  document.querySelectorAll('.slider--wrapper');
[...sliders].forEach(slider=>{

const sliderView = slider.querySelector('.slider--view > ul'),
    sliderViewSlides = slider.querySelectorAll('.slider--view__slides'),
    arrowLeft = slider.querySelector('.slider--arrows__left'),
    arrowRight = slider.querySelector('.slider--arrows__right'),
    sliderLength = sliderViewSlides.length;
    console.log(slider)
// sliding function
const slideMe = (sliderViewItems, isActiveItem) => {
    // update the classes
    isActiveItem.classList.remove('is-active');
    sliderViewItems.classList.add('is-active');

    // css transform the active slide position
    sliderView.setAttribute('style', 'transform:translateX('+ -1*( sliderViewItems.offsetLeft) + 'px)');
}

// before sliding function
const beforeSliding = i => {
    let isActiveItem = slider.querySelector('.slider--view__slides.is-active'),
        currentItem = Array.from(sliderViewSlides).indexOf(isActiveItem) + i,
        nextItem = currentItem + i,
        sliderViewItems = slider.querySelector(`.slider--view__slides:nth-child(${nextItem})`);
    // if nextItem is bigger than the # of slides
    if (nextItem > sliderLength) {
        sliderViewItems = slider.querySelector('.slider--view__slides:nth-child(1)');
    }

    // if nextItem is 0
    if (nextItem == 0) {
        sliderViewItems = slider.querySelector(`.slider--view__slides:nth-child(${sliderLength})`);
    }

    // trigger the sliding method
    slideMe(sliderViewItems, isActiveItem);
}



// triggers arrows
arrowRight.addEventListener('click', () => beforeSliding(0));
arrowLeft.addEventListener('click', () => beforeSliding(1));
})

}

document.addEventListener('DOMContentLoaded',activateSliders);
