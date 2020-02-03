export default class Regenerate
{
  constructor()
  {
    if (!this.setVars()) return;

    this.setEvents();
  }

  setVars()
  {
    this.section = document.querySelector('.webpLoader');
    if (!this.section) return;

    this.wrapper       = this.section.querySelector('.webpLoader__status');
    this.progress      = this.wrapper.querySelector('.webpLoader__barProgress');
    this.progressSize  = this.section.querySelector('.webpLoader__sizeProgress');
    this.errors        = this.section.querySelector('.webpLoader__errors');
    this.errorsInner   = this.errors.querySelector('.webpLoader__errorsContentList');
    this.errorsMessage = this.errors.querySelector('.webpLoader__errorsContentMessage');
    this.success       = this.section.querySelector('.webpLoader__success');
    this.button        = this.section.querySelector('.webpLoader__button');
    this.data = {
      count: 0,
      max: 0,
      items: [],
      size: {
        before: 0,
        after: 0,
      },
      errors: [],
    };
    this.settings = {
      isDisabled: false,
      ajax: {
        urlPaths: this.section.getAttribute('data-api-paths'),
        urlRegenerate: this.section.getAttribute('data-api-regenerate'),
      },
      units: ['kB', 'MB', 'GB'],
    };
    this.atts = {
      progress: 'data-percent',
    };
    this.classes = {
      progressError: 'webpLoader__barProgress--error',
      buttonDisabled: 'webpLoader__button--disabled',
    };

    return true;
  }

  setEvents()
  {
    this.button.addEventListener('click', this.initRegenerate.bind(this));
  }

  /* ---
    Load paths
  --- */
  initRegenerate(e)
  {
    e.preventDefault();
    if (this.settings.isDisabled) return;
    this.settings.isDisabled = true;
    this.button.classList.add(this.classes.buttonDisabled);

    this.wrapper.removeAttribute('hidden');
    this.getImagesList();
  }

  getImagesList()
  {
    jQuery.ajax(this.settings.ajax.urlPaths, {
      type: 'POST',
      date: {},
    }).done((response) => {
      this.data.items = response.data;
      this.data.max   = response.data.length;
      this.regenerateNextImages();
    }).fail(() => {
      this.progress.classList.add(this.classes.progressError);
      this.errorsMessage.removeAttribute('hidden');
      this.errors.removeAttribute('hidden');
    });
  }

  /* ---
    Regenerate request
  --- */
  regenerateNextImages()
  {
    if (this.data.max === 0) this.updateProgress();
    if (this.data.count >= this.data.max) return;

    const items = this.data.items[this.data.count];
    this.data.count++;
    this.sendRequest(items);
  }

  sendRequest(items)
  {
    jQuery.ajax(this.settings.ajax.urlRegenerate, {
      type: 'POST',
      data: {
        paths: items,
      },
    }).done((response) => {
      this.updateErrors(response);
      this.updateSize(response);
      this.updateProgress();
      this.regenerateNextImages();
    }).fail(() => {
      this.progress.classList.add(this.classes.progressError);
      this.errorsMessage.removeAttribute('hidden');
      this.errors.removeAttribute('hidden');
    });
  }

  /* ---
    Status
  --- */
  updateErrors(response)
  {
    if (response.errors.length === 0) return;

    this.data.errors = this.data.errors.concat(response.errors);
    this.errorsInner.innerHTML = this.data.errors.join('<br>');
    this.errors.removeAttribute('hidden');
  }

  updateSize(response)
  {
    const { size } = this.data;
    size.before += response.size.before;
    size.after  += response.size.after;

    let bytes = size.before - size.after;
    if (bytes < 0) bytes = 0;
    if (bytes === 0) return;

    let percent = Math.round((1 - (size.after / size.before)) * 100);
    if (percent < 0) percent = 0;

    let index = -1;
    do {
      index++;
      bytes /= 1024;
    } while (bytes > 1024);

    const number = bytes.toFixed(2);
    const unit   = this.settings.units[index];
    const value  = `${number} ${unit} (${percent}%)`;
    this.progressSize.innerHTML = value;
  }

  updateProgress()
  {
    let percent = (this.data.max > 0) ? Math.floor((this.data.count / this.data.max) * 100) : 100;
    if (percent > 100) percent = 100;
    if (percent === 100) this.success.removeAttribute('hidden');
    this.progress.setAttribute(this.atts.progress, percent);
  }
}
