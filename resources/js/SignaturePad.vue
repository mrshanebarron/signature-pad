<template>
  <div class="space-y-2">
    <div :class="['border-2 border-gray-300 rounded-lg overflow-hidden', canvasClass]">
      <canvas
        ref="canvasRef"
        @mousedown="startDrawing"
        @mousemove="draw"
        @mouseup="stopDrawing"
        @mouseleave="stopDrawing"
        @touchstart.prevent="handleTouchStart"
        @touchmove.prevent="handleTouchMove"
        @touchend="stopDrawing"
        class="w-full cursor-crosshair"
        :style="{ height: height + 'px' }"
      ></canvas>
    </div>
    <div class="flex gap-2">
      <button @click="clear" class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
        Clear
      </button>
      <button @click="save" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
        Save
      </button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
  name: 'SbSignaturePad',
  props: {
    modelValue: { type: String, default: '' },
    height: { type: Number, default: 200 },
    penColor: { type: String, default: '#000000' },
    lineWidth: { type: Number, default: 2 },
    canvasClass: { type: String, default: '' }
  },
  emits: ['update:modelValue', 'save'],
  setup(props, { emit }) {
    const canvasRef = ref(null);
    const isDrawing = ref(false);
    let ctx = null;
    let lastX = 0;
    let lastY = 0;

    const setupCanvas = () => {
      if (!canvasRef.value) return;
      const canvas = canvasRef.value;
      const rect = canvas.getBoundingClientRect();
      canvas.width = rect.width;
      canvas.height = props.height;
      ctx = canvas.getContext('2d');
      ctx.strokeStyle = props.penColor;
      ctx.lineWidth = props.lineWidth;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';
    };

    const getCoords = (e) => {
      const rect = canvasRef.value.getBoundingClientRect();
      const x = (e.clientX || e.touches?.[0]?.clientX) - rect.left;
      const y = (e.clientY || e.touches?.[0]?.clientY) - rect.top;
      return { x, y };
    };

    const startDrawing = (e) => {
      isDrawing.value = true;
      const { x, y } = getCoords(e);
      lastX = x;
      lastY = y;
    };

    const draw = (e) => {
      if (!isDrawing.value || !ctx) return;
      const { x, y } = getCoords(e);
      ctx.beginPath();
      ctx.moveTo(lastX, lastY);
      ctx.lineTo(x, y);
      ctx.stroke();
      lastX = x;
      lastY = y;
    };

    const stopDrawing = () => {
      isDrawing.value = false;
    };

    const handleTouchStart = (e) => startDrawing(e.touches[0]);
    const handleTouchMove = (e) => draw(e.touches[0]);

    const clear = () => {
      if (ctx && canvasRef.value) {
        ctx.clearRect(0, 0, canvasRef.value.width, canvasRef.value.height);
        emit('update:modelValue', '');
      }
    };

    const save = () => {
      if (canvasRef.value) {
        const dataUrl = canvasRef.value.toDataURL('image/png');
        emit('update:modelValue', dataUrl);
        emit('save', dataUrl);
      }
    };

    onMounted(() => {
      setupCanvas();
      window.addEventListener('resize', setupCanvas);
    });

    onUnmounted(() => {
      window.removeEventListener('resize', setupCanvas);
    });

    return { canvasRef, startDrawing, draw, stopDrawing, handleTouchStart, handleTouchMove, clear, save };
  }
};
</script>
