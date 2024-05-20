export default function CreateDiscussionsOwner () {
    return {
        init () {
            $( this.$root ).select2( {
                placeholder: 'Select an Owner',
                width: '100%',
            } );
        }
    };
}
