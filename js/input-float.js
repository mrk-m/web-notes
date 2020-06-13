const InputLabel = (() => {
  
  // add active class
  const handleFocus = (e) => {
    const target = e.target;
    target.parentNode.classList.add('active');
    target.parentNode.classList.add('focus');
    target.setAttribute('placeholder', target.getAttribute('data-placeholder'));
  };
  
  // remove active class
  const handleBlur = (e) => {
    const target = e.target;
    if(!target.value) {
      target.parentNode.classList.remove('active');
    }
    target.parentNode.classList.remove('focus');
    target.removeAttribute('placeholder');
  };
  
  // register events
  const bindEvents = (element) => {
    const inputField = element.querySelector('input');
    inputField.addEventListener('focus', handleFocus);
    inputField.addEventListener('blur', handleBlur);    
  };
  
  // get DOM elements
  const init = () => {
    const inputContainers = document.querySelectorAll('.input-container');

    inputContainers.forEach((element) => {

      if (element.querySelector('input').value) {
        element.classList.add('active');
      }

      bindEvents(element);
    });
  };
  
  return {
    init: init
  };
})();

InputLabel.init();

// autofill fix
$(document).ready(function() {
  $('input').trigger('input').trigger('change').trigger('keydown');
});