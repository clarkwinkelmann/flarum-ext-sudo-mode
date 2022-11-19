import app from 'flarum/common/app';
import Button from 'flarum/common/components/Button';
import Modal, {IInternalModalAttrs} from 'flarum/common/components/Modal';
import withAttr from 'flarum/common/utils/withAttr';

interface SudoModalAttrs extends IInternalModalAttrs {
    onsubmit: () => void
}

export default class SudoModal extends Modal<SudoModalAttrs> {
    password: string = ''

    className() {
        return 'SudoModal Modal--small';
    }

    title() {
        return app.translator.trans('clarkwinkelmann-sudo-mode.lib.sudo.title');
    }

    content() {
        return m('.Modal-body', [
            m('.Form-group', [
                m('p', app.translator.trans('clarkwinkelmann-sudo-mode.lib.sudo.message'))
            ]),
            m('.Form-group', [
                m('input.FormControl', {
                    type: 'password',
                    autocomplete: 'current-password',
                    value: this.password,
                    onchange: withAttr('value', (value: string) => {
                        this.password = value;
                    }),
                    placeholder: app.translator.trans('clarkwinkelmann-sudo-mode.lib.sudo.password'),
                }),
            ]),
            m('.Form-group', [
                Button.component({
                    type: 'submit',
                    className: 'Button Button--primary',
                }, app.translator.trans('clarkwinkelmann-sudo-mode.lib.sudo.submit')),
            ])
        ]);
    }

    onsubmit(event: Event) {
        event.preventDefault();

        this.loading = true;

        app.request<any>({
            method: 'POST',
            url: app.forum.attribute('apiUrl') + '/sudo-mode',
            body: {
                password: this.password,
            },
            errorHandler: this.onerror,
        }).then(response => {
            console.log(response);
            if (typeof response === 'object' && response.expires) {
                console.log('set', response.expires);
                app.forum.data.attributes!.sudoModeExpires = response.expires;
            }

            this.loading = false;
            this.hide();

            this.attrs.onsubmit();
        });
    }
}
