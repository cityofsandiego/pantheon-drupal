import { Plugin } from 'ckeditor5/src/core';
import { ButtonView } from 'ckeditor5/src/ui';


class LinkitMediaLibrary extends Plugin {

  buttonAdded = false;

  /**
   * @inheritdoc
   */
  static get requires() {
    return [];
  }

  init() {
    const { editor } = this;

    this._addMediaLibraryButton();
  }

  _addMediaLibraryButton() {
    const { editor } = this;
    const { locale } = editor;
    const linkUI = editor.plugins.get('LinkUI');
    const linkit = editor.plugins.get("Linkit");
    const _hideUIOriginal = linkUI._hideUI;
    const options = editor.config.get('linkitMediaLibrary');
    const linkFormView = linkUI.formView;
    const buttonView = new ButtonView(locale);

    const { libraryURL, openDialog, dialogSettings = {} } = options;
    if (!libraryURL || typeof openDialog !== 'function') {
      return;
    }

    // Create the toolbar button.
    buttonView.set({
      label: editor.t('Media Library'),
      withText: true,
    });
    buttonView.set( 'class', 'ck-media-library' );
    this.listenTo(buttonView, 'execute', () => {
      openDialog(
        libraryURL,
        ({ attributes }) => {
          // Add the media attributes into the Linkit plugin.
          linkit.set('entityType', attributes['data-entity-type']);
          linkit.set('entityUuid', attributes['data-entity-uuid']);
          linkit.set('entitySubstitution', attributes['data-entity-substitution']);
          linkFormView.urlInputView.fieldView.set('value', attributes.href);
          setTimeout(() => {
            linkFormView.urlInputView.fieldView.element.focus();
          }, 100)
        },

        dialogSettings,
      );
    });

    // For now, we are adding the button inside this event because Editor
    // Advanced Link is adding its form element so the Link UI form view in the
    // same way and if we don't do it like this, our changes get overridden.
    editor.plugins
      .get('ContextualBalloon')
      .on('set:visibleView', (evt, propertyName, newValue, oldValue) => {
          if (!this.buttonAdded && newValue !== oldValue && newValue === linkFormView) {
            linkFormView.children.add(buttonView, 1);
            this.buttonAdded = true;
          }
        }
      )

    // Here's the issue
    linkUI._hideUI = () => {
      const modal = document.querySelectorAll('#drupal-modal.ui-dialog-content');
      if (modal.length === 0) {
        _hideUIOriginal.bind(linkUI).call();
      }
    };

  }

  /**
   * @inheritdoc
   */
  static get pluginName() {
    return 'LinkitMediaLibrary';
  }
}
export default {
  LinkitMediaLibrary,
};
