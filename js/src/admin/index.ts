import app from 'flarum/admin/app';
import requireSudoMode from '../common/utils/requireSudoMode';

app.initializers.add('clarkwinkelmann-sudo-mode', () => {
    app.extensionData
        .for('clarkwinkelmann-sudo-mode')
        .registerSetting({
            type: 'number',
            setting: 'sudo-mode.duration',
            label: app.translator.trans('clarkwinkelmann-sudo-mode.admin.settings.duration'),
            placeholder: '3600',
        });

    // We want the sudo modal to open as soon as sudo mode expires in the admin panel since almost everything is restricted
    function refreshSudo() {
        // If forum not initialized yet, just skip until next round
        if (app.forum) {
            requireSudoMode();
        }

        setTimeout(() => {
            // Use requestAnimationFrame to reduce impact on idle tab
            // This way the sudo modal will open right when you switch back to the tab
            requestAnimationFrame(refreshSudo);
        }, 5000);
    }

    refreshSudo();
});
