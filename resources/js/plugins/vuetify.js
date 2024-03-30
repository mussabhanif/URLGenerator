import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

export default createVuetify({
  components,
  directives,
  theme: {
    themes: {
      light: {
       colors: {
        primary: '#E9C144',
        secondary: '#F5F5F5',
        accent: '#9747FF',
        error: '#FF0000',
        info: '#00A3FF',
        success: '#5ECF29',
        warning: '#FEB700'
       }
      }
    }
  }
})