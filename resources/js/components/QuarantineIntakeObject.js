/**
 * @typedef {Object} Item
 * @property {number} id
 * @property {string} text
 */

export default function QuarantineIntakeObject () {
    return {
        init () {
            this.initSelect2();
        },
        initSelect2 () {
            $( this.$refs.object )
                .select2( {
                    placeholder: 'Type the name of a Project or Opportunity',
                    width: '100%',
                    ajax: {
                        url: route( 'opportunities.projects.search' ),
                        dataType: 'json',
                        delay: 500,
                        /**
                         * @param {{ object_type: string, items: Item[] }} data
                         */
                        processResults: data => {
                            const { object_type, items } = data;
                            
                            this.$wire.$parent.form.object_type = object_type;

                            return {
                                results: items,
                            };
                        },
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', () => {
                    this.$wire.$parent.form.object_id = $( this.$refs.object ).val();
                });
        },
    };
}
