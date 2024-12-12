export default function QuarantineIntakeForm () {
    const maxDate = this.$refs.startsAt.dataset.nextMonthMaxDate;

    return {
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        init () {
            this.initStartsAtFlatpickr();
        },
        /**
         * @param {string} status
         */
        maybeClearSerialNumber ( status ) {
            if ( status === 'serial-number-exists' ) {
                return;
            }

            this.$wire.form.serial_number = '';
            this.serialNumberRemainingCharacters = 256;
        },
        clear () {
            this.$wire.form.project_or_opportunity = '';
            this.$wire.form.technical_supervisor = null;
            this.$wire.form.serial_number_status = 'serial-number-exists';
            this.$wire.form.serial_number = '';
            this.$wire.form.product_id = null;
            this.$wire.form.description = '';

            this.$dispatch( 'hermes:quarantine-intake-cleared' );
        },
        initStartsAtFlatpickr () {
            flatpickr( this.$refs.startsAt, {
                altInput: true,
                altFormat: 'd-M-Y',
                minDate: 'today',
                maxDate,
                /**
                 * @param {Date[]} _ 
                 * @param {string} dateStr 
                 */
                onChange: ( _, dateStr ) => {
                    this.$wire.form.starts_at = dateStr;
                },
            } );
        },
    };
}
