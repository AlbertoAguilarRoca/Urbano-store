
export const lenthCounterForm = (group) => {

    const input = group.querySelector('.form-input');
    
    input && input.addEventListener('keyup', () => {

        if(input.hasAttribute('maxlength')) {
            const maxlength = parseInt(input.getAttribute('maxlength'));
            const spanElement = group.querySelector('.input-length-counter');
            spanElement.innerText = `${input.value.length}/${maxlength}`;
        }
        
    });

}

export const setLengthToInitial = () => {

    const lengthtext = document.querySelectorAll('.input-length-counter');

    lengthtext.forEach( (text) => {
       const maxlength = text.innerText.split('/');
       text.innerText =  `0/${maxlength[1]}`;
    })


}