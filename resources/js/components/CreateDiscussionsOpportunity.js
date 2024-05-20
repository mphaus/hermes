export default function CreateDiscussionsOpportunity () {
    return {
        init () {
            $( this.$root ).select2( {
                placeholder: 'Select an Opportunity',
                width: '100%',
            } );
        }
    };
}
