export default function QuarantineStatsFilter () {
    return {
        filter: {
            time_period: '',
            date_period: '',
            products: [],
            technical_supervisors: [],
            objects: [],
            fault_root_causes: [],
            show_items_currently_in_quarantine: false,
        },
        init () {
            this.initFlatpickr();
        },
        initFlatpickr () {
            flatpickr( this.$refs.dateperiod, {
                mode: 'range',
                dateFormat: 'd-M-Y',
                maxDate: new Date,
                /**
                 * @param {Date[]} selectedDates 
                 */
                onChange: selectedDates => {
                    this.filter.date_period = selectedDates.map( selectedDate => `${ selectedDate.getUTCFullYear() }-${ ( selectedDate.getUTCMonth() + 1 ).toString().padStart( 2, '0' ) }-${ ( selectedDate.getUTCDate() ).toString().padStart( 2, '0' ) }` );
                    this.filter.time_period = '';
                },
            } );
        },
        /**
         * @param {PointerEvent} e 
         */
        toggleTimePeriod ( e ) {
            /** @type {{ target: HTMLButtonElement }} */
            const { target } = e;

            /** @type {{ timePeriod: string }} */
            const { timePeriod } = target.dataset;

            this.filter.time_period = this.filter.time_period === timePeriod ? '' : timePeriod;
        },
        /**
         * @param {HTMLButtonElement} element
         */
        toggleTimePeriodClassname ( element ) {
            const { timePeriod } = element.dataset;

            return {
                'button-primary': this.filter.time_period === timePeriod,
                'button-outline-primary': this.filter.time_period !== timePeriod,
            };
        },
    };
}
