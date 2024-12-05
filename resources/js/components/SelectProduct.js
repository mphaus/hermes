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
                .on( 'change.select2', () => this.$dispatch( 'hermes:select-product-change', { value: $( this.$root ).val() } ) );
        },
        clear () {
            $( this.$root ).val( null ).trigger( 'change' );
        },
    };
}
