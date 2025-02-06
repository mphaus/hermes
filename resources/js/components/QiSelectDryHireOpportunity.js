/**
 * @typedef {Object} Data
 * @property {string} id
 * @property {number} technical_supervisor_id
 * @property {string} text
 */

/**
 * @typedef {Object} Params
 * @property {string} term
 * @property {string} _type
 */


/**
 * @param {InputEvent} e
 */
function handleDryHireSearchInput ( e ) {
    /** @type {HTMLInputElement | null} */
    const element = e.target;

    if ( !element || element.value.length > 0 ) {
        return;
    }

    element.value = 'Q';
}

export default function QiSelectDryHireOpportunity () {
    /** @type {Data[]} */
    let currentData = [];

    return {
        value: '',
        init () {
            this.initSelect2();
        },
        destroy () {
            this.destroySelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    dropdownCssClass: 'hermes-qi-select-dry-hire-opportunity-dropdown',
                    placeholder: 'Type the digits of the Opportunity\'s quote number',
                    width: '100%',
                    ajax: {
                        url: route( 'qi-opportunities.search' ),
                        dataType: 'json',
                        delay: 500,
                        /**
                         * @param {Params} params 
                         * @returns 
                         */
                        data ( params ) {
                            return {
                                term: params.term,
                                'per_page': 25,
                                'q[number_cont]': '?',
                            };
                        },
                        /**
                         * @param {Data[]} data 
                         */
                        processResults ( data ) {
                            currentData = data;

                            return {
                                results: data,
                            };
                        },
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => {
                    const value = $( this.$root ).val();

                    if ( !value ) {
                        return;
                    }

                    this.value = value;
                    this.$dispatch( 'hermes:select-opportunity-change', { ...currentData.find( data => data.id === value ) } );
                } )
                .on( 'select2:open', () => {
                    /** @type {HTMLInputElement} */
                    const searchElement = document.querySelector( '.hermes-qi-select-dry-hire-opportunity-dropdown .select2-search__field' );

                    searchElement.value = 'Q';
                    searchElement.inputMode = 'numeric';
                    searchElement.maxLength = 6;
                    searchElement.addEventListener( 'input', handleDryHireSearchInput );
                } )
                .on( 'select2:closing', () => {
                    /** @type {HTMLInputElement} */
                    const searchElement = document.querySelector( '.hermes-qi-select-dry-hire-opportunity-dropdown .select2-search__field' );
                    searchElement.removeEventListener( 'input', handleDryHireSearchInput );
                } );
        },
        destroySelect2 () {
            $( this.$root ).select2( 'destroy' );
        },
        clear () {
            $( this.$root ).val( '' ).trigger( 'change' );
        },
        checkValue ( value ) {
            if ( value ) {
                return;
            }

            this.clear();
        },
    };
}
