# Signature Pad

Digital signature capture component for Laravel applications. Supports touch and mouse input, customizable colors and stroke width, and exports to PNG data URL. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/signature-pad
```

## Livewire Usage

### Basic Usage

```blade
<livewire:sb-signature-pad />
```

### Custom Dimensions

```blade
<livewire:sb-signature-pad
    :width="600"
    :height="200"
/>
```

### Custom Colors

```blade
<livewire:sb-signature-pad
    stroke-color="#0000FF"
    background-color="#F5F5F5"
/>
```

### Custom Stroke Width

```blade
<livewire:sb-signature-pad :stroke-width="3" />
```

### With Wire Model

```blade
<livewire:sb-signature-pad wire:model="signature" />
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `signature` | string | `null` | Base64 PNG data URL (modelable) |
| `width` | int | `400` | Canvas width in pixels |
| `height` | int | `200` | Canvas height in pixels |
| `strokeColor` | string | `'#000000'` | Pen color (hex) |
| `strokeWidth` | int | `2` | Line thickness in pixels |
| `backgroundColor` | string | `'#ffffff'` | Canvas background color |

### Methods

The component exposes a `clear()` method:

```blade
<livewire:sb-signature-pad wire:ref="signaturePad" />
<button wire:click="$refs.signaturePad.clear()">Clear</button>
```

## Vue 3 Usage

### Setup

```javascript
import { SbSignaturePad } from './vendor/sb-signature-pad';
app.component('SbSignaturePad', SbSignaturePad);
```

### Basic Usage

```vue
<template>
  <SbSignaturePad v-model="signature" />
</template>

<script setup>
import { ref } from 'vue';
const signature = ref(null);
</script>
```

### Custom Configuration

```vue
<template>
  <SbSignaturePad
    v-model="signature"
    :width="500"
    :height="250"
    stroke-color="#1a365d"
    :stroke-width="3"
    background-color="#edf2f7"
    ref="pad"
  />
  <button @click="$refs.pad.clear()">Clear</button>
  <button @click="save">Save</button>
</template>

<script setup>
import { ref } from 'vue';
const signature = ref(null);

function save() {
  console.log('Signature:', signature.value); // Base64 PNG
}
</script>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | String | `null` | v-model binding for signature data |
| `width` | Number | `400` | Canvas width |
| `height` | Number | `200` | Canvas height |
| `strokeColor` | String | `'#000000'` | Pen color |
| `strokeWidth` | Number | `2` | Line thickness |
| `backgroundColor` | String | `'#ffffff'` | Background color |

### Methods

| Method | Description |
|--------|-------------|
| `clear()` | Clear the signature canvas |
| `toDataURL()` | Get the signature as base64 PNG |
| `isEmpty()` | Check if canvas is empty |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `update:modelValue` | string | Emitted when signature changes |
| `signature-saved` | string | Emitted with data URL when saved |
| `signature-cleared` | - | Emitted when canvas is cleared |

## Saving Signatures

The signature is exported as a base64-encoded PNG data URL:

```php
// In your Livewire component
public string $signature = '';

public function save()
{
    // $this->signature contains: data:image/png;base64,...

    // Save to file
    $data = base64_decode(str_replace('data:image/png;base64,', '', $this->signature));
    file_put_contents(storage_path('signatures/sig.png'), $data);

    // Or save to database
    $user->update(['signature' => $this->signature]);
}
```

## Touch Support

The component supports:
- Mouse drawing (desktop)
- Touch drawing (tablets, phones)
- Prevents scrolling while signing

## Styling

The signature pad includes:
- Rounded border
- Shadow on focus
- Clear button styling
- Responsive container

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x

## License

MIT License
