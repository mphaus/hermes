export default function Qet () {
    let flatpickrInstance = null;

    return {
        init () {
            flatpickrInstance = flatpickr( this.$refs.date, {
                dateFormat: 'd-M-Y',
                minDate: new Date,
                onChange: ( selectedDates ) => {
                    console.log( selectedDates );
                    const date = selectedDates.length > 0
                        ? `${ selectedDates[ 0 ].getFullYear() }-${ ( selectedDates[ 0 ].getMonth() + 1 ).toString().padStart( 2, '0' ) }-${ ( selectedDates[ 0 ].getDate() ).toString().padStart( 2, '0' ) }`
                        : '';

                    this.$wire.setDate( date );
                }
            } );
        },
        clearDate () {
            flatpickrInstance.clear();
        }
    };
}
