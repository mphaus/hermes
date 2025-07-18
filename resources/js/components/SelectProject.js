/**
 * @typedef {Object} Data
 * @property {string} id
 * @property {string} text
 */

/**
 * @typedef {Object} Params
 * @property {string} term
 * @property {string} _type
 */

export default function SelectProject ( queryParams ) {
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
                    placeholder: 'Type the name of a Project',
                    width: '100%',
                    ajax: {
                        url: route( 'projects.search' ),
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
                        processResults ( data ) {
                            currentData = data;

                            return {
                                results: data,
                            };
                        }
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => {
                    const value = Number( $( this.$root ).val() );
                    console.log( value );

                    if ( !value ) {
                        return;
                    }

                    this.value = value;
                    this.$dispatch( 'hermes:select-project-change', { ...currentData.find( data => data.id === value ) } );
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
