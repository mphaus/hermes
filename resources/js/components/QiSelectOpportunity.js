export default function QiSelectOpportunity () {
    return {
        value: null,
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$root )
                .select2( {
                    placeholder: 'Type the name of an Opportunity',
                    width: '100%',
                    ajax: {
                        url: route( 'qi-opportunities.search' ),
                        dataType: 'json',
                        delay: 500,
                        processResults ( data ) {
                            return {
                                results: data,
                            };
                        },
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => {
                    if ( !$( this.$root ).val() ) {
                        return;
                    }

                    this.value = $( this.$root ).val();
                } );
        },
        checkValue ( value ) {
            if ( value ) {
                return;
            }

            this.clear();
        },
        clear () {
            $( this.$root ).val( null ).trigger( 'change' );
        }
    };
}
