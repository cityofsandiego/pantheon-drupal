import { Plugin } from 'ckeditor5/src/core';

class LinkableBrs extends Plugin {
  init() {
    const editor = this.editor;
    editor.model.schema.extend('softBreak', {
      allowAttributesOf: '$text'
    });
  }

  /**
   * @inheritdoc
   */
  static get pluginName() {
    return 'LinkableBrs';
  }
}

export default {
  LinkableBrs,
};
