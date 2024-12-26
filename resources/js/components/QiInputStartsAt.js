export default function QiInputStartsAt () {
    const currentDate = this.$root.dataset.currentDate;
    const maxDate = this.$root.dataset.nextMonthMaxDate;
    let instance = null;

    return {
        value: null,
        init () {
            this.initFlatpickr();
        },
        initFlatpickr () {
            instance = flatpickr( this.$root, {
                altInput: true,
                altFormat: 'd-M-Y',
                minDate: currentDate,
                maxDate,
                /**
                 * @param {Date[]} _ 
                 * @param {string} dateStr 
                 */
                onChange: ( _, dateStr ) => {
                    if ( !dateStr ) {
                        this.value = currentDate;
                        return;
                    }

                    this.value = dateStr;
                },
            } );
        },
        reset () {
            if ( instance === null ) {
                return;
            }

            instance.setDate( currentDate, true );
            this.value = currentDate;
        },
        checkValue ( value ) {
            if ( value !== currentDate ) {
                return;
            }

            this.reset();
        },
    };
}
