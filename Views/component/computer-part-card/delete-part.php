<div class="col-12">

    <?php if ($part !== null) : ?>
        <p>parts: <?= $part ? htmlspecialchars($part->getName()) : '' ?></p>
        <p>type : <?= $part ? htmlspecialchars($part->getType()) : '' ?></p>
        <p>Brand : <?= $part ? htmlspecialchars($part->getBrand()) : '' ?></p>
        <p>Model Number : <?= $part ? htmlspecialchars($part->getModelNumber()) : '' ?></p>
        <p>Release Date : <?= $part ? htmlspecialchars($part->getReleaseDate()) : '' ?></p>
        <p>Market Price: <?= $part ? $part->getMarketPrice() : '' ?>"</p>
        <p>rsm : <?= $part ? $part->getRsm() : '' ?></p>
        <p>powerConsumptionW : <?= $part ? $part->getPowerConsumptionW() : '' ?></p>
        <p>Dimensions (L x W x H)</p>
        <p>width : <?= $part ? $part->getHeightM() : '0' ?></p>
        <p>height : <?= $part ? $part->getHeightM() : '0' ?></p>
        <p>lifespan : <?= $part ? $part->getLifespan() : '0' ?></p>
    <?php endif; ?>
</div>
<div>
    <input id="delete_input" type="number">
    <button id="delete" class="btn btn-primary">delete</button>
</div>

<script src="/js/delete.js"></script>