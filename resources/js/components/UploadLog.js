export default function UploadLog ( appName, jobId ) {
    return {
        init () {
            const jobName = window.sessionStorage.getItem( `job${ jobId }` );

            if ( jobName ) {
                document.title = `${ appName } - ${ jobName } - Log`;
                document.querySelector( '[data-element=app-heading]' ).textContent = jobName;
            } else {
                this.$wire.getJob( jobId );
            }
        }
    }
}
