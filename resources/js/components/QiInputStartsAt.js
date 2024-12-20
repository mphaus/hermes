export default function QiInputStartsAt () {
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
                defaultDate: new Date,
                minDate: 'today',
                maxDate,
                /**
                 * @param {Date[]} _ 
                 * @param {string} dateStr 
                 */
                // onReady: ( _, dateStr ) => {
                //     if ( !dateStr ) {
                //         return;
                //     }

                //     this.value = dateStr;
                // },
                /**
                 * @param {Date[]} _ 
                 * @param {string} dateStr 
                 */
                onChange: ( _, dateStr ) => {
                    console.log( dateStr );


                    // if ( !dateStr ) {
                    //     return;
                    // }

                    this.value = dateStr;
                },
            } );
        },
        reset () {
            if ( instance === null ) {
                return;
            }

            instance.setDate( new Date, true );
        },
        checkValue ( value ) {
            if ( value ) {
                return;
            }

            this.reset();
        },
    };
}
