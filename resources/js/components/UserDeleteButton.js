export default function UserDeleteButton () {
    return {
        init () {
            this.$refs.dialog.addEventListener( 'close', () => {
                if ( this.$refs.dialog.returnValue !== 'ok' ) {
                    return;
                }

                console.log( 'It should delete the user.' );
            } );
        },
        showDialog () {
            this.$refs.dialog.showModal();
        }
    };
}
