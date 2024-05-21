export default function CreateDiscussionsOpportunity () {
    return {
        init () {
            $( this.$root ).select2( {
                placeholder: 'Select an Opportunity',
                width: '100%',
            } ).on( 'change.select2', () => this.$wire.$parent.form.opportunityId = $( this.$root ).val() );
        }
    };
}
