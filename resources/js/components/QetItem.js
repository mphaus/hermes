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
        _timeRemaining: 'Calculating...',
        init () {
            this.initCountDown();
        },
        initCountDown () {
            const startTime = new Date( startDate ).getTime();
            const endTime = new Date( endDate ).getTime();
            let currentTime = new Date( now ).getTime();
            let hours = 0;

            if ( currentTime < startTime ) {
                hours = Math.floor( ( endTime - startTime ) / 36e5 );
                this._timeRemaining = `${ hours }h`;

                this.$nextTick( () => {
                    this.$refs.timeRemainingElement.textContent = this._timeRemaining;
                } );

                return;
            }

            timeRemainingInterval = setInterval( () => {
                currentTime = new Date().getTime();
                const distance = endTime - currentTime;

                if ( distance < 0 ) {
                    clearInterval( timeRemainingInterval );
                    this._timeRemaining = '0h';

                    this.$nextTick( () => {
                        this.$refs.timeRemainingElement.textContent = this._timeRemaining;
                    } );

                    return;
                }

                hours = Math.floor( distance / 36e5 );

                this._timeRemaining = hours < 1 ? `-${ hours }h` : `${ hours }h`;
                this.$nextTick( () => {
                    this.$refs.timeRemainingElement.textContent = this._timeRemaining;
                } );
            }, 1000 );
        },
        destroy () {
            if ( timeRemainingInterval ) {
                clearInterval( timeRemainingInterval );
            }
        },
    };
}
