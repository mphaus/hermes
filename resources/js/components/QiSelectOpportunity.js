/**
 * @typedef {Object} Data
 * @property {string} id
 * @property {number} technical_supervisor_id
 * @property {string} text
 */

export default function QiSelectOpportunity () {
    /** @type {Data[]} */
    let currentData = [];

    return {
        value: '',
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    placeholder: 'Type the name of an Opportunity',
                    width: '100%',
                    ajax: {
                        url: route( 'qi-opportunities.search' ),
                        dataType: 'json',
                        delay: 500,
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
                    this.$dispatch( 'hermes:qi-select-opportunity-change', { ...currentData.find( data => data.id === value ) } );
                } );
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
