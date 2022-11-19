import app from 'flarum/common/app';
import SudoModal from '../components/SudoModal';

/**
 * Checks if sudo mode is enabled and prompt to enter if necessary.
 * Resolves promise with false if already in sudo mode.
 * Resolves promise with true if successfully entered sudo mode.
 * Rejects promise if user cannot be prompted.
 * Never resolves if the user closes the sudo modal.
 */
export default function (): Promise<boolean> {
    const expires = app.forum.attribute<number>('sudoModeExpires') || 0;
console.log('check', expires);
    if (expires > dayjs().unix()) {
        return Promise.resolve(false);
    }

    // If the sudo modal is already open, don't try to open it again
    // This is useful for the admin panel where a loop tries to open the modal
    if (app.modal.modalList.some(item => item.componentClass === SudoModal)) {
        return Promise.reject();
    }

    return new Promise(resolve => {
        app.modal.show(SudoModal, {
            onsubmit: () => {
                resolve(true);
            },
        }, true);
    });
}
