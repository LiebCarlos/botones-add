<?php
function agregar_botones_incremento_decremento() {
    if (is_product()) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
			 
var svgSelect = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none"><path d="M1 1L6 6L11 1" stroke="#6E808E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
var svgFecha = '<div class="date-ph"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 14 14" fill="none"><path d="M10.6 2.19995H3.4C2.07452 2.19995 1 3.27447 1 4.59995V10.6C1 11.9254 2.07452 13 3.4 13H10.6C11.9255 13 13 11.9254 13 10.6V4.59995C13 3.27447 11.9255 2.19995 10.6 2.19995Z" stroke="#6E808E" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.6 1V3.4M9.4 1V3.4M1 5.8H13" stroke="#6E808E" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="fecha-ph">Seleccionar fecha</span></div>';

var tdElements = document.querySelectorAll('.variations td.value');
tdElements.forEach(function(tdElement) {
    tdElement.insertAdjacentHTML('beforeend', svgSelect);
});

var dateElements = document.querySelectorAll('.wt-departure');
dateElements.forEach(function(dateElement) {
    dateElement.insertAdjacentHTML('beforeend', svgFecha);
});

const labelElement = document.querySelectorAll('.label label[for="seleccionar"]');

if (labelElement) {
	labelElement.forEach(ele =>{
		ele.textContent = 'Seleccionar una opción';
	});
} 

			
function agregarPh() {
    var inputElements = document.querySelectorAll('input[name="wt_date"]');
    inputElements.forEach(function(inputElement) {
        var placeholder = inputElement.closest('.wt-departure').querySelector('.fecha-ph');
        
        if (inputElement) {
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        if (inputElement.classList.contains('picker__input--active')) {
                            placeholder.style.opacity = '0';
                        } else {
                            if (!inputElement.value) {
                                placeholder.style.opacity = '1';
                            }
                        }
                    }
                });
            });

            observer.observe(inputElement, { attributes: true });
        }
    });
} 
           
function obtenerPrecioBase(selectName) {
	var precioBaseElement;
	if (selectName === 'wt_number_adult') {
		var elements = document.querySelectorAll('.woocommerce---price.adult-price bdi');
		precioBaseElement = elements[elements.length - 1]; 
	} else if (selectName === 'wt_number_child') {
		var elements = document.querySelectorAll('.woocommerce-variation-wt-child-price bdi');
		precioBaseElement = elements[elements.length - 1]; 
	} else if (selectName === 'wt_number_infant') {
		var elements = document.querySelectorAll('.woocommerce-variation-wt-infant-price bdi');
		precioBaseElement = elements[elements.length - 1];
	}


    if (precioBaseElement) {
        var precioTexto = precioBaseElement.textContent || precioBaseElement.innerText;

  
        precioTexto = precioTexto.replace(/[^0-9.,]/g, '');


        if (precioTexto.includes('.') && precioTexto.includes(',')) {
     
            if (precioTexto.indexOf('.') < precioTexto.indexOf(',')) {
                precioTexto = precioTexto.replace(/\./g, '').replace(',', '.');
            } else {
  
                precioTexto = precioTexto.replace(/,/g, '');
            }
        } else {
       
            if (precioTexto.includes('.')) {
                precioTexto = precioTexto.replace(/\./g, '');
            }
       
            if (precioTexto.includes(',')) {
                precioTexto = precioTexto.replace(/,/g, '.');
            }
        }

        var precioNumerico = parseFloat(precioTexto);
        return isNaN(precioNumerico) ? 0 : precioNumerico;
    }
}

			let primerClick = 0;
			
		function actualizarPrecioTotal(selectElement) {
			var totalPrice = 0;

			var urlParams = new URLSearchParams(window.location.search);
			var tieneAtributo = [...urlParams.keys()].some(key => key.startsWith('attribute_'));

			var closestContainer = selectElement.closest('.variations_form');
			var selectores = closestContainer.querySelectorAll('select[name="wt_number_adult"], select[name="wt_number_child"], select[name="wt_number_infant"]');

			selectores.forEach(function(select) {
				var precioBase = obtenerPrecioBase(select.name);
				var cantidad = parseInt(select.value, 10);

				totalPrice += precioBase * cantidad;
				if (select.name === 'wt_number_adult' && tieneAtributo && primerClick <= 2) {
					totalPrice -= precioBase; 
				} 
				if (select.name === 'wt_number_adult' && tieneAtributo && primerClick > 3) {
					totalPrice -= precioBase / 2; 
				} 
				primerClick++;
			});

			var totalPriceElement = closestContainer.querySelector('.price');
			totalPriceElement.textContent = '$' + totalPrice.toLocaleString();
		}


            function addIncrementDecrementButtons(selectElement) {
    if (selectElement) {
        // verifico
        var hasDecrementButton = selectElement.previousElementSibling && selectElement.previousElementSibling.classList.contains('decrement-btn');
        var hasIncrementButton = selectElement.nextElementSibling && selectElement.nextElementSibling.classList.contains('increment-btn');

        if (!hasDecrementButton && !hasIncrementButton) {
            var decrementButton = '<div class="decrement-btn" style="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">' +
                '<path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>' +
                '<path d="M6.40039 10H13.6004" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>' +
                '</div>';

            var incrementButton = '<div class="increment-btn" style="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">' +
                '<path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>' +
                '<path d="M10 6.40039V13.6004" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>' +
                '<path d="M6.40039 10H13.6004" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>' +
                '</svg>' +
                '</div>';

      
            selectElement.insertAdjacentHTML('beforebegin', decrementButton);
            selectElement.insertAdjacentHTML('afterend', incrementButton);


            selectElement.previousElementSibling.addEventListener('click', function() {
                var currentValue = parseInt(selectElement.value, 10);
                if (currentValue > 1) {
                    selectElement.value = currentValue - 1;
                    actualizarPrecioTotal(selectElement);
                }
                if (currentValue === 1 && selectElement.getAttribute('name') !== 'wt_number_adult') {
                    selectElement.value = currentValue - 1;
                    actualizarPrecioTotal(selectElement);
                }
            });

            selectElement.nextElementSibling.addEventListener('click', function() {
                var currentValue = parseInt(selectElement.value, 10);
                if (currentValue < 20) {
                    selectElement.value = currentValue + 1;
                    actualizarPrecioTotal(selectElement);
                }
            });
            selectElement.addEventListener('change', actualizarPrecioTotal);
					}
				} else {
					console.error("El elemento select no se estaría encontrando");
				}
			}

            function agregarBotonesASelectores() {
                var selectores = document.querySelectorAll('select[name="wt_number_adult"], select[name="wt_number_child"], select[name="wt_number_infant"]');
				console.log(selectores.length)
                selectores.forEach(function(selectElement) {
                    addIncrementDecrementButtons(selectElement);
                });
            }

			function agregarARS() {
				var priceElements = document.querySelectorAll('.p-price .woocommerce-Price-amount');

				priceElements.forEach(function(priceElement) {
					if (!priceElement.querySelector('.precio-moneda')) {
						priceElement.insertAdjacentHTML('afterbegin', '<span class="precio-moneda">ARS </span>');
					}
				});
			}


			setTimeout(function() {
					var days = document.querySelectorAll('.picker__day');
					days.forEach(function(day) {
						day.addEventListener('click', function() {
							setTimeout(function() {
								agregarARS();
							}, 1000);
						});
					});
				}, 500);

			//var trasladoSelect = document.querySelector('#seleccionar-una-opcion');
            var inputEl = document.querySelector('input[name="wt_date"]');
			
			if (inputEl) {
                agregarPh();
				var precios = document.querySelectorAll('#product_total_price .price');
			    precios.forEach(function(el){
				el.insertAdjacentHTML('beforebegin','<span class="precio-moneda-total">ARS </span>');				
				});
				
				
				var precioEl = document.querySelector('.woocommerce-Price-amount.amount bdi');
                var targetEl = document.querySelector('.precio-tour');
                targetEl.innerHTML = precioEl.innerHTML;
			}
			var trasladoSelects = document.querySelectorAll('#seleccionar'); 
		
			
			trasladoSelects.forEach(function(trasladoSelect) { 
				trasladoSelect.addEventListener('change', function() {
					setTimeout(function() {
						agregarBotonesASelectores();
						setTimeout(function() {
						agregarARS();
						}, 1000);
					}, 100);
				});
			});
        });
        </script>
        <?php
    }
}
add_action('wp_head', 'agregar_botones_incremento_decremento');
