/**
 * @typedef {Object} State
 * @property {boolean} disabled
 * @property {boolean} loading
 * @property {HTMLOptionElement} [element]
 * @property {string} [id]
 * @property {boolean} [selected]
 * @property {string} text
 * @property {string} [title]
 * @property {string} [_resultId]
 */

export default function QuarantineSelectPrimaryFaultClassification () {
    let isDirty = false;

    return {
        value: '',
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    placeholder: 'Select an option',
                    width: '100%',
                    /**
                     * @param {State} state
                     */
                    templateResult ( state ) {
                        const { element, text } = state;

                        if ( element === undefined ) {
                            return state.text;
                        }

                        /** @type {{ example: string }} */
                        const { example } = element.dataset;

                        return $( /* html */`<span class="font-semibold">${ text }</span><br><span class="text-sm">${ example }</span>` );
                    },
                } )
                .on( 'change.select2', () => {
                    this.value = $( this.$root ).val();
                    isDirty = true;
                } );
        },
        clear () {
            $( this.$root ).val( '' ).trigger( 'change' );
        },
        checkValue ( value ) {
            if ( value || !isDirty ) {
                return;
            }

            this.clear();
        },
    };
}
