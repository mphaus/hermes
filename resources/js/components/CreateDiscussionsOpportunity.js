export default function CreateDiscussionsOpportunity () {
    return {
        init () {
            $( this.$root ).select2( {
                placeholder: 'Type the name of an Opportunity',
                width: '100%',
                ajax: {
                    url: route( 'opportunities.search' ),
                    dataType: 'json',
                    delay: 250,
                    processResults ( data ) {
                        return {
                            results: data,
                        };
                    }
                },
                minimumInputLength: 1,
            } ).on( 'change.select2', () => this.$wire.$parent.form.opportunityId = $( this.$root ).val() );
        }
    };
}
