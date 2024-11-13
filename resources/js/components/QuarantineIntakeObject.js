/**
 * @typedef {Object} Item
 * @property {number} id
 * @property {string} text
 * @property {number} technical_supervisor_id
 * @property {boolean} [selected]
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
        technicalSupervisorName: '',
        technicalSupervisorDoesNotExist: false,
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
                .on( 'change.select2', () => {
                    this.technicalSupervisorName = '';
                    this.$wire.$parent.form.technical_supervisor = '';
                    this.technicalSupervisorDoesNotExist = false;

                    const selectedValue = $( this.$refs.object ).val()
                    this.$wire.$parent.form.object_id = selectedValue;

                    const selectedResult = itemResults.find( item => item.selected );

                    if ( selectedResult === undefined ) {
                        this.technicalSupervisorDoesNotExist = true;
                        return;
                    }

                    const technicalSupervisor = technicalSupervisors.find( supervisor => supervisor.id === selectedResult.technical_supervisor_id );

                    if ( technicalSupervisor === undefined ) {
                        this.technicalSupervisorDoesNotExist = true;
                        return;
                    }

                    this.technicalSupervisorName = technicalSupervisor.name;
                    this.$wire.$parent.form.technical_supervisor = technicalSupervisor.id;
                } );
        },
        clear () {
            $( this.$refs.object ).val( null ).trigger( 'change' );
        }
    };
}
