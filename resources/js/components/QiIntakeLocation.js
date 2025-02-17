export default function QiIntakeLocation () {
    /** @type {HTMLInputElement} */
    const rootElement = this.$root;

    return {
        value: '',
        /**
         * @param {InputEvent} e 
         */
        applyMask ( e ) {
            /** @type {{ target: HTMLInputElement }} */
            const { target } = e;
            const value = target.value;
            const lettersRegex = /^[a-iA-I]$/;
            const numbersRegex = /^([1-9]|[1-3][0-9]|4[0-5])$/;

            if ( value.length === 1 ) {
                if ( lettersRegex.test( value ) ) {
                    this.value = `${ value.toUpperCase() }-`;
                } else {
                    this.value = '';
                }
            }

            if ( value.length > 2 ) {
                const numberPart = value.slice( 2 );
                if ( !numbersRegex.test( numberPart ) ) {
                    this.value = value.slice( 0, -1 );
                }
            }
        },
        /**
         * @param {KeyboardEvent} e 
         */
        removeValue ( e ) {
            /** @type {{ target: HTMLInputElement }} */
            const { target } = e;

            if ( e.key === 'Backspace' ) {
                this.value = target.value;
                if ( target.value.length === 2 ) {
                    this.value = '';
                    e.preventDefault();
                }

                console.log( this.value );
            };
        },
    };
}
