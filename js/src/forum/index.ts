import {override} from 'flarum/common/extend';
import app from 'flarum/forum/app';
import User from 'flarum/common/models/User';
import UserControls from 'flarum/forum/utils/UserControls';
import requireSudoMode from '../common/utils/requireSudoMode';

app.initializers.add('clarkwinkelmann-sudo-mode', () => {
    function userActionWithSudo(original: (user: User) => any, user: User) {
        if (!user.attribute('couldEditWithSudo')) {
            return original(user);
        }

        requireSudoMode().then(newSudo => {
            if (newSudo) {
                // Refresh user with new permissions
                app.store.find('users', user.id()!).then(() => {
                    // Prevent issues when going from one modal to another
                    setTimeout(() => {
                        original(user);
                    }, 300);
                });
            } else {
                original(user);
            }
        });
    }

    override(UserControls, 'editAction', userActionWithSudo);
    override(UserControls, 'deleteAction', userActionWithSudo);
});
