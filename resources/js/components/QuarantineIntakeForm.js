export default function QuarantineIntakeForm () {
    return {
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        /**
         * @param {string} status
         */
        maybeClearSerialNumber ( status ) {
            if (status === 'serial-number-exists') {
                return;
            }

            this.$wire.form.serial_number = '';
            this.serialNumberRemainingCharacters = 256;
        }
    };
}
