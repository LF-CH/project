package com.dev.ecoexplorer.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.Utils;
import com.dev.ecoexplorer.databinding.ItemStepsBinding;
import com.dev.ecoexplorer.routes.RoutePath;
import com.dev.ecoexplorer.routes.RouteStep;

import java.util.List;

public class StepsAdapter extends RecyclerView.Adapter<StepsAdapter.Vh> {

    List<RoutePath> list;
    Context context;

    public StepsAdapter(List<RoutePath> list, Context context) {
        this.list = list;
        this.context = context;
    }

    @NonNull
    @Override
    public Vh onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view= LayoutInflater.from(context).inflate(R.layout.item_steps,parent,false);
        return new Vh(view);
    }

    @Override
    public void onBindViewHolder(@NonNull Vh holder, int position) {
        RoutePath routeStep=list.get(position);
        holder.binding.tvStep.setText(routeStep.getInstruction());
        holder.binding.tvTime.setText(Utils.formatDuration(routeStep.getDuration()));
        holder.binding.tvDistance.setText(Utils.formatDistance(routeStep.getDistance()));


    }

    @Override
    public int getItemCount() {
        return list.size();
    }

    public static class Vh extends RecyclerView.ViewHolder {
        ItemStepsBinding binding;
        public Vh(@NonNull View itemView) {
            super(itemView);
            binding=ItemStepsBinding.bind(itemView);
        }
    }
}
