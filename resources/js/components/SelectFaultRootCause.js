/**
 * @typedef {Object} SelectFaultRootCauseProps
 * @property {boolean} multiple
 */

/**
 * @export
 * @param {SelectFaultRootCauseProps} props
 */
export default function SelectFaultRootCause ( props ) {
    const { multiple } = props;

    return {
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    multiple,
                    placeholder: 'Type the name of a Fault Root cause',
                    width: '100%',
                } )
                .on( 'change.select2', () => this.$dispatch( 'hermes:select-fault-root-cause-change', { value: $( this.$root ).val() } ) );
        },
        clear () {
            $( this.$root ).val( null ).trigger( 'change' );
        },
    };
}