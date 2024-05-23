/**
 * @typedef {Object} Member
 * @property {number} id
 * @property {string} name
 */

export default function CreateDiscussionsOwner () {
    return {
        init () {
            /** @type {Member[]} */
            const members = JSON.parse( this.$root.dataset.members );

            $( this.$root ).select2( {
                placeholder: 'Select an Account Manager',
                width: '100%',
            } ).on( 'change.select2', () => {
                /** @type {number} */
                const value = Number( $( this.$root ).val() );

                /** @type {Member} */
                const member = members.find( member => member.id === value );

                this.$dispatch( 'hermes:create-discussions-owner-change', { owner: member.name } );
                this.$wire.$parent.form.userId = value;
            } );
        }
    };
}
