export default function ActionStreamFilters (
    initialMemberIds,
    initialActionTypes,
    initialDateRange,
    formattedDateRange,
    initialTimePeriod
) {
    return {
        memberIds: initialMemberIds,
        actionTypes: initialActionTypes,
        dateRange: initialDateRange,
        timePeriod: initialTimePeriod,
        _flatpickrInstance: null,
        init () {
            $( this.$refs.memberIds ).select2( {
                placeholder: 'Select or type one or more members',
                width: '100%',
            } ).on( 'change.select2', () => this.memberIds = $( this.$refs.memberIds ).val() );

            if ( this.memberIds.length > 0 ) {
                $( this.$refs.memberIds )
                    .val( this.memberIds )
                    .trigger( 'change' );
            }

            $( this.$refs.actionTypes ).select2( {
                placeholder: 'Select or type one or more actions',
                width: '100%',
            } ).on( 'change.select2', () => this.actionTypes = $( this.$refs.actionTypes ).val() );

            if ( this.actionTypes.length > 0 ) {
                $( this.$refs.actionTypes )
                    .val( this.actionTypes )
                    .trigger( 'change' );
            }

            this._flatpickrInstance = flatpickr( this.$refs.dateRange, {
                mode: 'range',
                dateFormat: 'd-M-Y',
                maxDate: new Date,
                defaultDate: [ ...formattedDateRange ],
                onChange: ( selectedDates ) => {
                    if ( selectedDates.length === 0 ) {
                        this.dateRange = [];
                        return;
                    }

                    this.dateRange = selectedDates.map( selectedDate => `${ selectedDate.getUTCFullYear() }-${ ( selectedDate.getUTCMonth() + 1 ).toString().padStart( 2, '0' ) }-${ ( selectedDate.getUTCDate() ).toString().padStart( 2, '0' ) }` );
                },
            } );
        },
        clear () {
            this.memberIds = [];
            this.actionTypes = [];
            this.dateRange = [];
            this.timePeriod = '';

            $( this.$refs.memberIds ).val( [] ).trigger( 'change' );
            $( this.$refs.actionTypes ).val( [] ).trigger( 'change' );
            this._flatpickrInstance.clear();

            this.$wire.$parent.setFilters( this.memberIds, this.actionTypes, this.dateRange, this.timePeriod );
        }
    };
}
