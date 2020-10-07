document.addEventListener('DOMContentLoaded',function (){
    const form = document.querySelector('.wordpress-ajax-form');
    form.addEventListener('submit',(e)=>{
        e.preventDefault()
        const FD = new FormData(form);
        form.reset();
        const XHR = new XMLHttpRequest();
        const messageWrapper = document.createElement('P');
        // Define what happens on successful data submission
        XHR.addEventListener( "load", function(event) {
            const res = JSON.parse(event.target.responseText)
            console.log(res);
            if(res.error) messageWrapper.style.color = "red";
            messageWrapper.appendChild(document.createTextNode(res.error_message||res.message))
            form.appendChild(messageWrapper)
        } );

        // Define what happens in case of error
        XHR.addEventListener( "error", function( event ) {
            messageWrapper.style.color = "red";
            messageWrapper.appendChild(document.createTextNode('Oops something went wrong'))
            form.appendChild(messageWrapper)
        } );

        // Set up our request
        XHR.open( "POST", form.getAttribute('action') );

        // The data sent is what the user provided in the form
        XHR.send( FD );



    })
})

