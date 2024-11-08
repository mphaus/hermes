/**
 * @typedef {Object} Item
 * @property {number} id
 * @property {string} text
 * @property {number} technical_supervisor_id
 */

/**
 * @typedef {Object} TechnicalSupervisor
 * @property {number} id
 * @property {string} name
 */

/**
 * @export
 * @param {TechnicalSupervisor[]} technicalSupervisors
 */
export default function QuarantineIntakeObject ( technicalSupervisors ) {
    /** @type {Item[]} */
    let itemResults = [];

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

                            itemResults = items;

                            this.$wire.$parent.form.object_type = object_type;

                            return {
                                results: items,
                            };
                        },
                    },
                    minimumInputLength: 1,
                } )
                .on( 'change.select2', ( e ) => {
                    const selectedValue = $( this.$refs.object ).val()
                    this.$wire.$parent.form.object_id = selectedValue;
                });
        },
    };
}
