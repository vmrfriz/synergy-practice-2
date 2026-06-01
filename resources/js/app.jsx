import { createInertiaApp } from '@inertiajs/react'
import Layout from './Layout'

createInertiaApp({
    strictMode: true,
    layout: () => Layout,
})
