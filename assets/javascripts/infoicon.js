document.addEventListener(
	'DOMContentLoaded',
	() => {
		customElements.define(
		'solea-info-icon',
		class extends HTMLElement {
			connectedCallback() {
				const value         = this.getAttribute( 'value' ) || '';
				const tooltip       = document.createElement( 'div' );
				tooltip.className   = 'tooltip';
				tooltip.textContent = value;
				this.appendChild( tooltip );

				this.addEventListener(
					'mouseover',
					() => {
						tooltip.style.visibility = 'visible';
						tooltip.style.opacity    = '1';
					}
				);

				this.addEventListener(
					'mouseout',
					() => {
                    tooltip.style.visibility = 'hidden';
                    tooltip.style.opacity    = '0';
					}
				);
			}
		}
		);
	}
);