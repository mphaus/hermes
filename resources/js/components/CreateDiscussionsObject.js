export default function CreateDiscussionsObject () {
    let select2Instance = null;

    return {
        _createOnProject: false,
        discussionObjectType: '',
        /**
         * @param {boolean} createOnProject
         */
        initSelect2 ( createOnProject = false ) {
            if ( select2Instance ) {
                select2Instance.val( null ).trigger( 'change' );
                select2Instance.select2( 'destroy' );
            }

            this.discussionObjectType = createOnProject ? 'Project' : 'Opportunity';

            const options = {
                placeholder: createOnProject ? 'Type the name of a Project' : 'Type the name of an Opportunity',
                width: '100%',
                ajax: {
                    url: createOnProject ? route( 'projects.search' ) : route( 'opportunities.search' ),
                    dataType: 'json',
                    delay: 500,
                    processResults ( data ) {
                        return {
                            results: data,
                        };
                    }
                },
                minimumInputLength: 1,
            };

            select2Instance = $( this.$refs.discussionObject ).select2( options ).on( 'change.select2', () => this.$wire.$parent.form.objectId = $( this.$refs.discussionObject ).val() );
        }
    };
}
