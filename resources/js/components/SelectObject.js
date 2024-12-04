/** 
 * @typedef {object} SelectObjectProps
 * @property {boolean} multiple
 * @property {number | string[]} [initialValue]
 */

/**
 * @typedef {Object} Item
 * @property {number} id
 * @property {string} text
 * @property {number} technical_supervisor_id
 * @property {boolean} [selected]
 */

/**
 * @export
 * @param {SelectObjectProps} props
 */
export default function SelectObject ( props ) {
    const { multiple } = props;

    return {
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    multiple,
                    placeholder: 'Type the name of a Project or Opportunity',
                    width: '100%',
                    ajax: {
                        url: route( 'opportunities.projects.search' ),
                        dataType: 'json',
                        delay: 500,
                        /**
                         * @param {Item[]} data
                         */
                        processResults ( data ) {
                            return {
                                results: data,
                            };
                        },
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => this.$dispatch( 'hermes:select-object-change', { value: $( this.$root ).val() } ) );
        },
        clear () {
            $( this.$root ).val( null ).trigger( 'change' );
        },
    };
}
