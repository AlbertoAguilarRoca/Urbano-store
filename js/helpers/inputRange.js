
const rangeInput = document.querySelectorAll('.range-input input');
const progress = document.querySelector('.slider .progress');
const priceInput = document.querySelectorAll('.price-inputs input');



priceInput.forEach( input => {
    input.addEventListener('change', (e) => {
        //recojo los dos valores y los parseo a integer
        let minVal = parseInt(priceInput[0].value), 
        maxVal = parseInt(priceInput[1].value);

        if(maxVal > minVal && maxVal <= 650) {
            if(e.target.className === 'input-min') {
                progress.style.left = `${(minVal / rangeInput[0].max) * 100}%`;
                rangeInput[0].value = minVal; //uno es la diferencia de precio entre maximo y min
            } else {
                progress.style.right = `${100 - (maxVal / rangeInput[1].max) * 100}%`;
                rangeInput[1].value = maxVal;
            }
        } else {
            if(minVal > maxVal) {
                minVal = maxVal - 1
                priceInput[0].value = minVal;
                progress.style.left = `${(minVal / rangeInput[0].max) * 100}%`;
                rangeInput[0].value = minVal;

                progress.style.right = `${100 - (maxVal / rangeInput[1].max) * 100}%`;
                rangeInput[1].value = maxVal;
            }
        }
    });
});



rangeInput.forEach( input => {
    input.addEventListener('input', (e) => {
        //recojo los dos valores y los parseo a integer
        let minVal = parseInt(rangeInput[0].value), 
        maxVal = parseInt(rangeInput[1].value);

        if(maxVal > minVal) {
            progress.style.left = `${(minVal / rangeInput[0].max) * 100}%`;
            progress.style.right = `${100 - (maxVal / rangeInput[1].max) * 100}%`;

            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
        } else {
            if(e.target.className === 'min-range') {
                rangeInput[0].value = maxVal - 1; //uno es la diferencia de precio entre maximo y min
            } else {
                rangeInput[1].value = minVal + 1;
            }
        }
    });
});