<template>
    <!-- <fulfilling-bouncing-circle-spinner :animation-duration="4000" :size="60" color="#ff1d5e" /> -->
    <div class="flex">
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <!-- <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" />
        <looping-rhombuses-spinner :animation-duration="1200" :rhombus-size="15" color="#ff1d5e" /> -->
    </div>

</template>

<script>
import { FulfillingBouncingCircleSpinner } from 'epic-spinners'
import { LoopingRhombusesSpinner } from 'epic-spinners'

export default{
    components: {
        FulfillingBouncingCircleSpinner,
        LoopingRhombusesSpinner
    }
}
</script>
