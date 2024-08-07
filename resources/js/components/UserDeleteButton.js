export default function UserDeleteButton () {
    return {
        init () {
            this.$refs.dialog.addEventListener( 'close', () => {
                if ( this.$refs.dialog.returnValue !== 'ok' ) {
                    return;
                }

                this.$dispatch( 'hermes:user-delete' );
                this.$wire.delete();
            } );
        },
        showDialog () {
            this.$refs.dialog.showModal();
        }
    };
}
