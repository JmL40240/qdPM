<h1>Wiki List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Description</th>
      <th>User</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($wiki_list as $wiki): ?>
    <tr>
      <td><a href="<?php echo url_for('wiki/edit?id='.$wiki->getId()) ?>"><?php echo $wiki->getId() ?></a></td>
      <td><?php echo $wiki->getName() ?></td>
      <td><?php echo $wiki->getDescription() ?></td>      
      <td><?php echo $wiki->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('wiki/new') ?>">New</a>
