<h2>Lista de Jogos</h2>
<ul>
    <?php if(!empty($lista_jogo) && is_array($lista_jogo)): ?>
        <?php foreach($lista_jogo as $jogos): ?>
            <li>
                [<?php echo $jogos['categoria']; ?>] 
                <strong><?php echo $jogos['titulo']; ?></strong> - 
                <?php echo $jogos['fabricante']; ?> | 
                R$ <?php echo number_format($jogos['preco'], 2, ',', '.'); ?>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum jogo encontrado.</p>
    <?php endif; ?>
</ul>