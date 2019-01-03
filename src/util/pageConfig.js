let tdk = {
  title: '',
  description: '',
  keywords: '',
  bodyClass: '',
}

function getPageConfig(vm) {
  const {pageConfig} = vm.$options;
  if (pageConfig) {
    return typeof pageConfig === 'function'
        ? Object.assign({}, tdk, pageConfig.call(vm))
        : Object.assign({}, tdk, pageConfig);
  }
}

const serverTitleMixin = {
  created() {
    const pageConfig = getPageConfig(this);
    if (pageConfig) {
      this.$ssrContext.title = `${pageConfig.title}`;
      this.$ssrContext.keywords = `${pageConfig.keywords}`;
      this.$ssrContext.description = `${pageConfig.description}`;
      this.$ssrContext.bodyClass = `${pageConfig.bodyClass}`;
      this.$store.commit('PAGE_TITLE', pageConfig.title);
    }
  }
}

function csetTitie(that) {
  const pageConfig = getPageConfig(that)
  if (pageConfig) {
    document.title = `${pageConfig.title}`;
    document.querySelector('meta[name="description"]').setAttribute('content', `${pageConfig.description}`);
    document.querySelector('meta[name="keywords"]').setAttribute('content', `${pageConfig.keywords}`);
    that.$store.commit('PAGE_TITLE', pageConfig.title);
    if (pageConfig.bodyClass) {
      document.getElementsByTagName('body')[0].setAttribute('class', `${pageConfig.bodyClass}`);
    } else {
      document.getElementsByTagName('body')[0].removeAttribute('class');
    }
  }
}

const clientTitleMixin = {
  created() {
    if (typeof window !== 'undefined') {
      csetTitie(this);
    }
  }
}

export default process.env.VUE_ENV === 'server'
    ? serverTitleMixin
    : clientTitleMixin