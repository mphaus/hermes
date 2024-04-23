/**
 * @export
 * @param {string} now
 * @param {string} startDate
 * @param {string} endDate
 */
export default function QetItem ( now, startDate, endDate ) {
    /** @type {ReturnType<typeof setInterval> | null} */
    let timeRemainingInterval = null;

    return {
        timeRemaining: 'Calculating...',
        init () {
            this.initCountDown();
        },
        initCountDown () {
            const startTime = new Date( startDate ).getTime();
            const endTime = new Date( endDate ).getTime();
            let currentTime = new Date( now ).getTime();
            let hours = 0;

            if ( currentTime < startTime ) {
                hours = Math.abs( ( endTime - startTime ) / 36e5 );
                this.timeRemaining = `${ hours }h`;

                return;
            }

            timeRemainingInterval = setInterval( () => {
                currentTime = new Date().getTime();
                const distance = endTime - currentTime;

                if ( distance < 0 ) {
                    clearInterval( timeRemainingInterval );
                    this.timeRemaining = '0h';
                    return;
                }

                hours = Math.abs( distance / 36e5 );
                this.timeRemaining = hours < 1 ? `-${ hours }h` : `${ hours }h`;
            }, 1000 );
        },
        destroy () {
            if ( timeRemainingInterval ) {
                clearInterval( timeRemainingInterval );
            }
        },
    };
}
