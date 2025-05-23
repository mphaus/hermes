/**
 * @typedef {Object} State
 * @property {number} [id]
 * @property {string} text
 * @property {string} [thumb_url]
 */

/**
 * @typedef {Object} SelectProductProps
 * @property {boolean} multiple
 */

/**
 * @export
 * @param {SelectProductProps} props
 */
export default function SelectProduct ( props ) {
    const { multiple } = props;

    return {
        value: 0,
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    multiple,
                    placeholder: 'Type the name of a Product',
                    width: '100%',
                    ajax: {
                        url: route( 'products.search' ),
                        dataType: 'json',
                        delay: 500,
                        processResults ( data ) {
                            return {
                                results: data,
                            };
                        },
                    },
                    minimumInputLength: 1,
                    /**
                     * @param {State | undefined} state
                     */
                    templateResult ( state ) {
                        if ( state.id === undefined || ( state.thumb_url !== undefined && state.thumb_url === '' ) ) {
                            return state.text;
                        }

                        return $(/* html */`<span class="flex items-center gap-2"><img src="${ state.thumb_url }"><span>${ state.text }</span></span>` );
                    },
                } )
                .on( 'change.select2', e => {
                    if ( $( this.$root ).val() ) {
                        window.sessionStorage.setItem( 'hermes-select-product-html', JSON.stringify( e.target.innerHTML ) );
                        this.value = Number( $( this.$root ).val() );

                        return;
                    }

                    window.sessionStorage.removeItem( 'hermes-select-product-html' );
                } );
        },
        checkValue ( value ) {
            if ( value ) {
                return;
            }

            this.clear();
        },
        clear () {
            $( this.$root ).val( 0 ).trigger( 'change' );
        },
    };
}
