/**
 * @typedef {Object} SelectTechnicalSupervisorProps
 * @property {boolean} multiple
 */

/**
 * @export
 * @param {SelectTechnicalSupervisorProps} props
 */
export default function SelectTechnicalSupervisor ( props ) {
    const { multiple } = props;

    return {
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    multiple,
                    placeholder: 'Type the name of a Technical Supervisor',
                    width: '100%',
                } )
                .on( 'change.select2', () => this.$dispatch( 'hermes:select-technical-supervisor-change', { value: $( this.$root ).val() } ) );
        },
        clear () {
            $( this.$root ).val( null ).trigger( 'change' );
        },
    };
}
