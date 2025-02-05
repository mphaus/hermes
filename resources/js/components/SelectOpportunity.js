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

export default function SelectOpportunity ( queryParams ) {
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
                    placeholder: 'Type the name of an Opportunity',
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
                            let query = {
                                term: params.term,
                            };

                            if ( queryParams ) {
                                query = {
                                    ...query,
                                    ...queryParams,
                                }
                            }

                            return query;
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
